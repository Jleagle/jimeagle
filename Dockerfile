# Build image
FROM golang:1.19-alpine AS build-env
WORKDIR /root/
COPY ./ ./
RUN apk update \
    && apk add git \
    && CGO_ENABLED=0 GOOS=linux go build -a

# Runtime image
FROM alpine:3.10 AS runtime-env
WORKDIR /root/
COPY --from=build-env /root/jimeagle ./
COPY assets ./assets
COPY templates ./templates
RUN apk update && apk add ca-certificates curl bash
CMD ["./jimeagle"]
