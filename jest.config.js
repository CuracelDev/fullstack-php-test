module.exports = {
    "moduleFileExtensions": [
        "js",
        "json",
        "vue"
    ],
    transform: {
        "\\.[jt]sx?$": "babel-jest",
        ".*\\.(vue)$": "vue-jest"
    },
    moduleNameMapper: {
        "@/(.*)": "<rootDir>/src/$1",
    },
    testEnvironment: 'jsdom',
    transformIgnorePatterns: ["node_modules/(?!axios)/"],
}
