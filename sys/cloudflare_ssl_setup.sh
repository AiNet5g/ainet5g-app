#!/bin/bash

# Cloudflare SSL Setup for ai-net.app
# Run this script after obtaining SSL certificates from Cloudflare

echo "Setting up Cloudflare SSL for ai-net.app..."

# Install nginx and certbot
sudo apt update
sudo apt install -y nginx certbot python3-certbot-nginx

# Create SSL certificate directory
sudo mkdir -p /etc/ssl/certs /etc/ssl/private

# Set proper permissions
sudo chmod 700 /etc/ssl/private

echo "SSL directories created."
echo ""
echo "Next steps:"
echo "1. Download your Cloudflare SSL certificate files:"
echo "   - Origin certificate (.pem file)"
echo "   - Private key (.key file)"
echo ""
echo "2. Copy them to the server:"
echo "   sudo cp your-certificate.pem /etc/ssl/certs/ai-net.app.pem"
echo "   sudo cp your-private.key /etc/ssl/private/ai-net.app.key"
echo ""
echo "3. Set proper permissions:"
echo "   sudo chmod 644 /etc/ssl/certs/ai-net.app.pem"
echo "   sudo chmod 600 /etc/ssl/private/ai-net.app.key"
echo ""
echo "4. Copy nginx configuration:"
echo "   sudo cp nginx_ssl_config.conf /etc/nginx/sites-available/ai-net.app"
echo "   sudo ln -s /etc/nginx/sites-available/ai-net.app /etc/nginx/sites-enabled/"
echo ""
echo "5. Test and reload nginx:"
echo "   sudo nginx -t"
echo "   sudo systemctl reload nginx"
echo ""
echo "6. Start the AI NET 5G system:"
echo "   sudo python3 fixed_production_launcher.py"
