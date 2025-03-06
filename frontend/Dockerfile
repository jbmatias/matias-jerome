# Vue 3 dockerfile
# using node 18

# pull official base image
FROM node:18

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install app dependencies
COPY package.json ./
# COPY package-lock.json ./
RUN npm install

# add app
COPY . ./

# expose port
EXPOSE 3000

# start app
CMD ["npm", "run", "dev"]