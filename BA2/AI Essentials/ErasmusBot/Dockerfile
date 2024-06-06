FROM node:18 AS npm-stage

WORKDIR /app

COPY web/package.json web/package-lock.json ./
RUN npm install

COPY web ./

RUN npm run build:prod
RUN npm run tailwind:prod


FROM golang:1.22.3 as go-stage

WORKDIR /app

COPY go.work ./go.work
COPY go.work.sum ./go.work.sum

COPY ./bot ./bot
COPY ./config ./config
COPY ./db ./db
COPY ./models ./models
COPY ./server ./server

RUN go build -o /erasmusbot-server ./server

FROM frolvlad/alpine-glibc:latest

WORKDIR /app

COPY --from=go-stage /erasmusbot-server /app/erasmusbot-server
COPY --from=npm-stage /app/public/ /app/web/public
COPY --from=npm-stage /app/views/ /app/web/views

RUN apk add --no-cache ca-certificates

CMD ["./erasmusbot-server"]