#!/bin/bash

# Check if Railway CLI is installed
if ! command -v railway &> /dev/null; then
    echo "Installing Railway CLI..."
    npm install -g @railway/cli
fi

# Login to Railway
echo "Logging in to Railway..."
railway login

# Initialize project if it doesn't exist
if ! railway connect | grep -q "cc1"; then
    echo "Creating new project..."
    railway init
fi

# Set environment variables
echo "Setting environment variables..."
railway variables \
    REACT_APP_API_URL=https://callcenter-api.up.railway.app \
    CORS_ALLOW_ORIGIN=https://callcenter.up.railway.app \
    APP_ENV=prod \
    APP_DEBUG=0 \
    PHP_VERSION=8.2

# Deploy the application
echo "Deploying application..."
railway up

echo "Deployment complete! Check your Railway dashboard for the deployment status." 