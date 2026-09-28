#!/bin/bash
cd "$(dirname "$0")"
PORT=8080
(sleep 1; open "http://localhost:$PORT/pages/shop/home/index.html") &
python3 -m http.server $PORT
