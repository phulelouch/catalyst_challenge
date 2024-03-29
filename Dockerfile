FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update && \
    apt-get install -y php8.1-cli php8.1-mysqli mysql-server curl && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /usr/src/app

COPY user_upload.php .
COPY start.sh .

# Make sure the script is executable
RUN chmod +x ./start.sh

ENTRYPOINT ["./start.sh"]
