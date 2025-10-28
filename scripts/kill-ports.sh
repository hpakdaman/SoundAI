#!/bin/bash

# Kill processes running on Laravel and Vite development ports
echo "🔍 Checking for processes on Laravel and Vite ports..."

for port in 8000 8001 8002 8003 8004 8005 5173; do
    # Find process ID using lsof
    PID=$(lsof -ti:$port)

    if [ ! -z "$PID" ]; then
        echo "🚫 Killing process $PID on port $port"
        kill -9 $PID
        sleep 1

        # Verify the process was killed
        if lsof -ti:$port > /dev/null 2>&1; then
            echo "⚠️  Warning: Process on port $port might still be running"
        else
            echo "✅ Port $port is now free"
        fi
    else
        echo "✅ Port $port is already free"
    fi
done

echo "🎉 Port cleanup complete!"
