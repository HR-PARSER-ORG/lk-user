FROM node:14-alpine

WORKDIR /lkuser

COPY package.json ./
COPY package-lock.json ./

RUN npm install

#prod
#CMD ["npm", "run", "build"]

#dev
CMD [ -d "node_modules" ] && npm run dev-server || npm ci && npm run dev-server