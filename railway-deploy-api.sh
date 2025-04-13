#!/bin/bash

# Check if Railway CLI is installed
if ! command -v railway &> /dev/null; then
    echo "Installing Railway CLI..."
    npm install -g @railway/cli
fi

# Login to Railway
echo "Logging in to Railway..."
railway login

# Initialize API project if it doesn't exist
if ! railway connect | grep -q "callcenter-api"; then
    echo "Creating new API project..."
    railway init
fi

# Set API environment variables
echo "Setting API environment variables..."
railway variables add APP_ENV=prod
railway variables add APP_DEBUG=0
railway variables add PHP_VERSION=8.2
railway variables add DATABASE_URL=mysql://app:app@mysql:3306/app
railway variables add CORS_ALLOW_ORIGIN=https://callcenter.up.railway.app

# Deploy the API
echo "Deploying API..."
railway up

echo "API deployment complete! Check your Railway dashboard for the deployment status." 