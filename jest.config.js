module.exports = {
    "testEnvironment": "jsdom",
    "moduleFileExtensions": [
        "js",
        "json",
        "vue"
    ],
    "transform": {
        "^[^.]+.vue$": "@vue/vue2-jest",
        ".*\\.(js)$": "babel-jest"
    }
};
