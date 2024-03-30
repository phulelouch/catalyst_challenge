FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# RUN apt-get update && apt-get install -y software-properties-common
# RUN add-apt-repository ppa:ondrej/php -y
# RUN apt-get update && \
#     apt-get install -y php8.1-cli php8.1-mysqli mysql-server curl && \
#     apt-get clean && \
#     rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php -y && \
    apt-get update && \
    apt-get install -y \
    php8.1-cli \
    php8.1-mysqli \
    mysql-server \
    curl \
    net-tools \  
    && apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /usr/src/app

# COPY user_upload.php .
# COPY users.csv .
# COPY start.sh .
# COPY utils/ ./utils/
# COPY tests/ ./tests/
# COPY test_data.csv ./test_data.csv
COPY ./ ./

RUN chmod +x ./start.sh

ENTRYPOINT ["./start.sh"]
