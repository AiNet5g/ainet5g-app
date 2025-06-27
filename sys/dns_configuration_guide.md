# DNS Configuration for ai-net.app

## Required DNS Records

To point ai-net.app to your server (45.32.124.14), configure these DNS records in your domain registrar:

```
Type    Name            Value               TTL
A       ai-net.app      45.32.124.14        300
A       www.ai-net.app  45.32.124.14        300
CNAME   *.ai-net.app    ai-net.app          300
```

## Step-by-Step DNS Setup

### 1. Access Your Domain Registrar
- Log into your domain registrar (GoDaddy, Namecheap, Cloudflare, etc.)
- Navigate to DNS management for ai-net.app

### 2. Add A Records
```
Record 1:
- Type: A
- Name: @ (or leave blank for root domain)
- Value: 45.32.124.14
- TTL: 300 seconds

Record 2:
- Type: A  
- Name: www
- Value: 45.32.124.14
- TTL: 300 seconds
```

### 3. Verify DNS Propagation
After adding records, check propagation:
```bash
# Check from your server
nslookup ai-net.app
dig ai-net.app

# Should return: 45.32.124.14
```

## Complete Setup Command

Once DNS is configured, run this single command on your server:

```bash
chmod +x complete_ai_net_setup.sh && sudo ./complete_ai_net_setup.sh
```

This will:
- Install and configure Nginx reverse proxy
- Obtain free SSL certificate from Let's Encrypt
- Set up automatic HTTPS redirect
- Create systemd service for auto-startup
- Configure firewall rules

## After Setup

Your system will be accessible at:
- https://ai-net.app
- https://www.ai-net.app

The WiFi hotspot "AI-NET-5G" with password "AINet2024!" will be available through the web interface.

## Verification

Test the complete setup:
```bash
curl -I https://ai-net.app
# Should return: HTTP/2 200
```
