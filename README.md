# Call Center Scheduler

A modern call center scheduling system built with API Platform (backend) and React (frontend).

## Project Structure

```
call-center/
├── api/                 # API Platform backend
├── frontend/           # React frontend
└── docker/             # Docker configuration
```

## Features

- Agent management with availability and efficiency tracking
- Queue management
- Shift scheduling
- Demand forecasting
- Automated schedule generation

## Requirements

- PHP 8.2+
- Node.js 18+
- MySQL 8.0+
- Docker (optional)

## Getting Started

### Backend Setup

1. Navigate to the api directory
2. Install dependencies: `composer install`
3. Configure your database in `.env`
4. Run migrations: `php bin/console doctrine:migrations:migrate`

### Frontend Setup

1. Navigate to the frontend directory
2. Install dependencies: `npm install`
3. Start development server: `npm start`

## Development

- Backend API documentation available at `/api/docs`
- Frontend development server runs on port 3000 