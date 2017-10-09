pipeline {
    agent any

    stages {
        stage('Build Dev') {
            when {
                branch 'dev'
            }
            steps {
                dir('/home/serieall/serieall-dev') {
                    sh 'id'
                    sh 'git pull'
                    sh 'php composer.phar self-update'
                    sh 'php composer.phar update'
                    sh 'php artisan cache:clear'
                    sh 'php artisan queue:restart'
                    echo 'test'
                }
            }
        }
    }
}