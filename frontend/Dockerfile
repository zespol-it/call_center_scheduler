# Build stage
FROM node:18-alpine AS build

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies with production flag and clean cache
RUN npm ci --only=production --no-audit --no-fund && \
    npm cache clean --force

# Copy source code
COPY . .

# Build the app
RUN npm run build

# Production stage
FROM nginx:alpine

# Copy nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copy built files from build stage
COPY --from=build /app/build /usr/share/nginx/html

# Expose port
EXPOSE 8000

# Start nginx
CMD ["nginx", "-g", "daemon off;"] 