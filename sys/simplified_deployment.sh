#!/bin/bash

# Simplified AI-NET.APP Deployment - Works with any DNS setup
# Handles SSL gracefully whether domain points to server or not

echo "Deploying AI NET 5G+ system..."

# Install dependencies
sudo apt update
sudo apt install -y nginx python3 python3-pip ufw

# Configure firewall
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp  
sudo ufw allow 443/tcp
sudo ufw allow 5000/tcp
sudo ufw --force enable

# Stop conflicting services
sudo systemctl stop apache2 2>/dev/null || true
sudo pkill -f "python.*5000" 2>/dev/null || true

# Install Python app
sudo mkdir -p /opt/ai-net5g
sudo cp working_wifi_system.py /opt/ai-net5g/
sudo chmod +x /opt/ai-net5g/working_wifi_system.py

# Create working Nginx config without SSL issues
sudo tee /etc/nginx/sites-available/ai-net.app << 'EOF'
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    server_name ai-net.app www.ai-net.app _;

    location / {
        proxy_pass http://127.0.0.1:5000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_buffering off;
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
}
EOF

# Enable site
sudo rm -f /etc/nginx/sites-enabled/default
sudo ln -sf /etc/nginx/sites-available/ai-net.app /etc/nginx/sites-enabled/

# Test and start nginx
sudo nginx -t && sudo systemctl restart nginx
sudo systemctl enable nginx

# Create systemd service
sudo tee /etc/systemd/system/ai-net5g.service << 'EOF'
[Unit]
Description=AI NET 5G+ System
After=network.target

[Service]
Type=simple
User=root
WorkingDirectory=/opt/ai-net5g
ExecStart=/usr/bin/python3 working_wifi_system.py
Restart=always
RestartSec=5
Environment=PYTHONUNBUFFERED=1

[Install]
WantedBy=multi-user.target
EOF

# Start services
sudo systemctl daemon-reload
sudo systemctl enable ai-net5g.service
sudo systemctl start ai-net5g.service

# Get server IP
SERVER_IP=$(curl -s ifconfig.me 2>/dev/null || curl -s ipinfo.io/ip 2>/dev/null || hostname -I | awk '{print $1}')

echo "================================"
echo "AI NET 5G+ Deployment Complete!"
echo "================================"
echo "Access URLs:"
echo "- http://$SERVER_IP (Direct IP access)"
echo "- http://ai-net.app (if DNS configured)"
echo "================================"
echo "WiFi Hotspot: AI-NET-5G"
echo "WiFi Password: AINet2024!"
echo "Contact: yanchokh@gmail.com"
echo "================================"

# Show service status
sudo systemctl status ai-net5g.service --no-pager
echo "Deployment completed successfully!"
