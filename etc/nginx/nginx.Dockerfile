FROM nginx:stable-alpine

COPY ./etc/nginx/default.conf /etc/nginx/conf.d/

CMD ["nginx", "-g", "daemon off;"]