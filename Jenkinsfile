pipeline 
{
    agent 
    {
        label 'docker-node'
    }
    environment 
    {
        DOCKERHUB_CREDENTIALS=credentials('docker-hub')
    }
    stages 
    {
        stage('Clone') 
        {
            steps 
            {
                git branch: 'main', url: 'http://192.168.99.102:3000/gs/bgapp'
            }
        }
        stage('Build & Run')
        {
            steps
            {
                sh 'docker volume rm bgapp_db || true'
                sh 'docker compose -f docker-compose.yaml up -d'
            }
        }
        stage('Test')
        {
            steps
            {
                script 
                {
                    echo 'Test #1 - reachability'
                    sh "sleep 5"
                    sh 'echo $(curl --write-out "%{http_code}" --silent --output /dev/null http://localhost:8080) | grep 200'

                    echo 'Test #2 - data'
                    sh "sleep 5"
                    sh "curl -s http://localhost:8080 | grep Русе"
                }
            }
        }
        stage('CleanUp')
        {
            steps
            {
                sh 'docker compose -f docker-compose.yaml down'
            }
        }
        stage('Login') 
        {
            steps 
            {
                sh 'echo $DOCKERHUB_CREDENTIALS_PSW | docker login -u $DOCKERHUB_CREDENTIALS_USR --password-stdin'
            }
        }
        stage('Push') 
        {
            steps 
            {
                echo "Publish bgapp-web"
                sh 'docker image tag bgapp-pipeline-web amashofdna/bgapp-web:latest'
                sh 'docker push amashofdna/bgapp-web:latest'
                
                echo "Publish bgapp-db"
                sh 'docker image tag bgapp-pipeline-db amashofdna/bgapp-db:latest'
                sh 'docker push amashofdna/bgapp-db:latest'
            }
        }
        stage('Deploy')
        {
            steps
            {
                sh 'docker compose -f docker-compose-prod.yaml up -d'
            }
        }
    }
}
