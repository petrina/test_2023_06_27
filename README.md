## Environment Variables

Make sure to update the `.env` file with the following environment variables:
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=postgres
DB_PASSWORD=password


# Prerequisites: Install Node.js version 18

# Step 1: Install dependencies
npm install

# Step 2: Run frontend resource compilation
npm run dev


# Prerequisites: Install Docker

# Step 1: Build Docker containers
docker-compose build

# Step 2: Start Docker containers
docker-compose up -d

# Step 3: Enter the "app" container
docker exec -it app bash

# Step 4: Generate application key
php artisan key:generate

# Step 5: Run database migrations
php artisan migrate

# Step 6: Run scheduled tasks
php artisan schedule:run

