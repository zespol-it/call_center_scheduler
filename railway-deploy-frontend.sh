#!/bin/bash

# Check if Railway CLI is installed
if ! command -v railway &> /dev/null; then
    echo "Installing Railway CLI..."
    npm install -g @railway/cli
fi

# Login to Railway
echo "Logging in to Railway..."
railway login

# Initialize frontend project if it doesn't exist
if ! railway connect | grep -q "callcenter-frontend"; then
    echo "Creating new frontend project..."
    railway init
fi

# Set frontend environment variables
echo "Setting frontend environment variables..."
railway variables add REACT_APP_API_URL=https://callcenter-api.up.railway.app
railway variables add NODE_ENV=production

# Deploy the frontend
echo "Deploying frontend..."
railway up

echo "Frontend deployment complete! Check your Railway dashboard for the deployment status." 