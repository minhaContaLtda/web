#!/bin/bash
docker run -it --rm --link web_db_1:postgres postgres psql -h postgres -U username dbname
