#!/bin/bash

# Install Railway CLI if not installed
if ! command -v railway &> /dev/null; then
    echo "Installing Railway CLI..."
    npm install -g @railway/cli
fi

# Login to Railway
railway login

# Create new project if not exists
railway init

# Set environment variables
railway variables set \
    REACT_APP_API_URL="https://callcenter-api.up.railway.app" \
    CORS_ALLOW_ORIGIN="https://callcenter.up.railway.app" \
    MYSQL_DATABASE="app" \
    MYSQL_USER="app" \
    MYSQL_PASSWORD="$(openssl rand -base64 32)" \
    MYSQL_ROOT_PASSWORD="$(openssl rand -base64 32)"

# Deploy to Railway
railway up

echo "Deployment completed! Check your Railway dashboard for the deployment status." 