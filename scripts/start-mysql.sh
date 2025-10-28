#!/bin/bash

# Laravel AI Music Composer - MySQL Auto-Start Script
# This script ensures MySQL starts properly before development
# Works with Herd (preferred) and fallback to traditional MySQL

echo "🔧 Starting MySQL for Laravel AI Music Composer..."

# Function to check if MySQL is running
check_mysql() {
    if lsof -Pi :3306 -sTCP:LISTEN -t >/dev/null 2>&1; then
        return 0
    else
        return 1
    fi
}

# Function to test MySQL connection
test_mysql_connection() {
    if mysql -u root -e "SELECT 'MySQL is working!' as status;" 2>/dev/null; then
        echo "✅ MySQL connection verified"
        return 0
    else
        echo "⚠️  MySQL is running but connection needs configuration"
        return 1
    fi
}

# Check if MySQL is already running
if check_mysql; then
    echo "✅ MySQL is already running on port 3306"
    test_mysql_connection
else
    echo "🚀 Starting MySQL server..."

    # Try Herd first (recommended for Laravel development)
    if command -v herd >/dev/null 2>&1; then
        echo "🔧 Using Herd to start services..."
        herd start

        # Wait for services to start
        sleep 5

        if check_mysql; then
            echo "✅ MySQL started successfully via Herd"
            test_mysql_connection
        else
            echo "❌ Herd failed to start MySQL, trying fallback..."
            # Fallback to traditional MySQL start
            mysql.server start
            sleep 3

            if check_mysql; then
                echo "✅ MySQL started successfully via mysql.server"
                test_mysql_connection
            else
                echo "💥 Failed to start MySQL with both methods"
                exit 1
            fi
        fi
    else
        echo "🔧 Herd not found, using mysql.server..."
        mysql.server start
        sleep 3

        if check_mysql; then
            echo "✅ MySQL started successfully via mysql.server"
            test_mysql_connection
        else
            echo "💥 Failed to start MySQL"
            exit 1
        fi
    fi
fi

echo "🌐 MySQL is ready for development"
