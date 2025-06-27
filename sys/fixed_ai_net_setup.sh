#!/bin/bash

# Fixed AI-NET.APP Complete Setup Script
# This version properly handles SSL certificate installation

echo "Setting up AI-NET.APP complete system..."

# Update system and install required packages
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx certbot python3-certbot-nginx ufw curl wget

# Configure firewall
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 443
sudo ufw allow 5000
sudo ufw allow 51820
sudo ufw --force enable

# Stop any existing services
sudo systemctl stop nginx
sudo pkill -f "python.*5000" 2>/dev/null || true

# Create initial HTTP-only nginx configuration for Let's Encrypt
sudo tee /etc/nginx/sites-available/ai-net.app << 'EOF'
server {
    listen 80;
    server_name ai-net.app www.ai-net.app;
    
    # Allow Let's Encrypt challenge
    location /.well-known/acme-challenge/ {
        root /var/www/html;
    }
    
    # Proxy everything else to Flask
    location / {
        proxy_pass http://127.0.0.1:5000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_buffering off;
        proxy_read_timeout 300;
        proxy_connect_timeout 300;
        proxy_send_timeout 300;
    }
}
EOF

# Enable the site and test configuration
sudo ln -sf /etc/nginx/sites-available/ai-net.app /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default

# Test nginx configuration
sudo nginx -t

if [ $? -ne 0 ]; then
    echo "Nginx configuration error"
    exit 1
fi

# Start nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# Install Python application first
sudo mkdir -p /opt/ai-net5g
sudo cp working_wifi_system.py /opt/ai-net5g/
sudo chmod +x /opt/ai-net5g/working_wifi_system.py

# Create systemd service for AI NET 5G
sudo tee /etc/systemd/system/ai-net5g.service << 'EOF'
[Unit]
Description=AI NET 5G+ WiFi and VPN System
After=network.target

[Service]
Type=simple
User=root
WorkingDirectory=/opt/ai-net5g
ExecStart=/usr/bin/python3 /opt/ai-net5g/working_wifi_system.py
Restart=always
RestartSec=10
Environment=PYTHONUNBUFFERED=1

[Install]
WantedBy=multi-user.target
EOF

# Enable and start the service
sudo systemctl daemon-reload
sudo systemctl enable ai-net5g.service
sudo systemctl start ai-net5g.service

# Wait for service to start
sleep 5

# Check if service is running
if sudo systemctl is-active --quiet ai-net5g.service; then
    echo "AI NET 5G service started successfully"
else
    echo "Warning: AI NET 5G service may not have started properly"
    sudo systemctl status ai-net5g.service
fi

# Install SSL certificate using Let's Encrypt
echo "Installing SSL certificate for ai-net.app..."
sudo certbot --nginx -d ai-net.app -d www.ai-net.app --non-interactive --agree-tos --email yanchokh@gmail.com --redirect

# If certbot fails, create a manual HTTPS configuration
if [ $? -ne 0 ]; then
    echo "Let's Encrypt failed, creating manual HTTPS configuration..."
    
    # Create self-signed certificate as fallback
    sudo mkdir -p /etc/ssl/ai-net
    sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout /etc/ssl/ai-net/ai-net.app.key \
        -out /etc/ssl/ai-net/ai-net.app.crt \
        -subj "/C=US/ST=State/L=City/O=Organization/CN=ai-net.app"
    
    # Update nginx config with self-signed certificate
    sudo tee /etc/nginx/sites-available/ai-net.app << 'EOF'
server {
    listen 80;
    server_name ai-net.app www.ai-net.app;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name ai-net.app www.ai-net.app;

    # Self-signed SSL certificate
    ssl_certificate /etc/ssl/ai-net/ai-net.app.crt;
    ssl_certificate_key /etc/ssl/ai-net/ai-net.app.key;
    
    # SSL configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    
    # Security headers
    add_header Strict-Transport-Security "max-age=63072000" always;
    add_header X-Frame-Options DENY;
    add_header X-Content-Type-Options nosniff;
    add_header X-XSS-Protection "1; mode=block";

    # Proxy to Flask application
    location / {
        proxy_pass http://127.0.0.1:5000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_buffering off;
        proxy_read_timeout 300;
        proxy_connect_timeout 300;
        proxy_send_timeout 300;
    }

    # WebSocket support
    location /ws {
        proxy_pass http://127.0.0.1:5000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
EOF
fi

# Test and reload nginx
sudo nginx -t && sudo systemctl reload nginx

# Set up auto-renewal for Let's Encrypt (if available)
sudo systemctl enable certbot.timer 2>/dev/null || true
sudo systemctl start certbot.timer 2>/dev/null || true

echo "Setup complete!"
echo "================================"
echo "AI NET 5G+ is now available at:"
echo "- https://ai-net.app"
echo "- https://www.ai-net.app"
echo "- http://$(curl -s ifconfig.me):5000 (direct access)"
echo "================================"
echo "WiFi Network: AI-NET-5G"
echo "WiFi Password: AINet2024!"
echo "Contact: yanchokh@gmail.com"
echo "================================"

# Show service status
echo "Service status:"
sudo systemctl status ai-net5g.service --no-pager -l

# Test the endpoints
echo "Testing endpoints..."
curl -I http://localhost:5000 2>/dev/null && echo "✅ Local HTTP working"
curl -I https://ai-net.app 2>/dev/null && echo "✅ HTTPS working" || echo "⚠️  HTTPS needs DNS configuration"

echo "Setup completed successfully!"
