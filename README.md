# catalyst_challenge


## Table of Contents

- [Catalyst Challenge](#catalyst_challenge)
  - [Table of Contents](#table-of-contents)
  - [Feature Completion Status](#features_completion_status)
 - [Feature Completion Status](#features_completion_status)

## Feature Completion Status


Below is the list of features and their completion status. 

- [x] Create a Docker environment with Dockerfile the united with the Assumptions in the task (Ubuntu 22.04, Mysql)
- [x] Perform basic requirements
- [x] Apply Security measurement: DOS (import from CSV)
- [x] Apply Security measurement: SQL Injection (import from CSV)
- [ ] Apply Security measurement: OS Injection
- [ ] Generate test script
- [ ] A frontend web for easy test
- [ ] Create a docker-compose.yml to have a seperate volume so that we can do docker run directly without have to use /bin/bash
- [ ] Fix the database config, it is better to create a DBConfig class or create a .env 
- [ ] Expose the docker so that it can insert into other Mysql database outside

## Installation
1. Install the assumptions environment: Ubuntu 22.04, php8.1, mysql

2. Build the docker:
   ```bash
   #Build the docker
   docker build -t catalyst .
   ```
## Run the script  
1. Run with the assumptions environment

2. Access the docker terminal and run the script:
  - Access /bin/bash:
  ```bash
   #Access the terminal inside docker
   docker run -it --rm catalyst /bin/bash
   ```
  - Run the script:
   ```bash
    php user_upload.php [options]  
   ```

3. Run the script directly

*Note: This will not preserve the database since the database is in the docker as php script (all inside the Ubuntu docker).*
*This is the assumptions I made: in case the database is outside of docker we can expose the docker and the script will still run as an independence tools.*

  - Run with script:
  ```bash
    #Run directly
    docker run -it --rm catalyst --file test_data.csv
  ```


