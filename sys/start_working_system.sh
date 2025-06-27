#!/bin/bash

# Kill any existing processes on port 5000
sudo lsof -ti:5000 | xargs sudo kill -9 2>/dev/null || true
sudo pkill -f "python.*5000" 2>/dev/null || true
sleep 2

# Install dependencies if missing
sudo apt update && sudo apt install -y hostapd dnsmasq wireless-tools iw iptables net-tools python3 python3-pip lsof curl

# Install Python packages
pip3 install flask gunicorn qrcode[pil]

# Make script executable
chmod +x working_wifi_system.py

echo "Starting AI NET 5G+ System..."
echo "Web interface will be available at: http://$(hostname -I | awk '{print $1}'):5000"

# Start the working system
sudo python3 working_wifi_system.py
