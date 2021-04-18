Postgresql is using bitnami chart - https://github.com/bitnami/charts/tree/master/bitnami/postgresql

Its config can be found under ./charts/postgresql



Deployment via helm:

Change alerts email in values.yaml (and postgre_host if not installing the helm release with name "app")



helm install app .



Accessing the app:

kubectl port-forward app-xxxxxx-xxxx 8080:80

or enable minikube ingress plugin and set ingress enabled: true in values.yaml


Open in browser

http://localhost:8080/?n=5
http://localhost:8080/blacklisted/
http://localhost:8080/test
http://localhost:8080/test/email.php



