FROM redis:8.0.3-alpine
LABEL authors="Timur Davydov"

CMD ["redis-server"]