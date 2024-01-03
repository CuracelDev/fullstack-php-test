module.exports = {
    // Where are your vue tests located?
    "roots": [
        "<rootDir>/resources/js/tests"
    ],
    // vue: transform vue with vue-jest to make jest understand Vue's syntax
    // js: transform js files with babel, we can now use import statements in tests
    "transform": {
        ".*\\.(vue)$": "<rootDir>/node_modules/vue-jest",
        "^.+\\.js$": "<rootDir>/node_modules/babel-jest"
    },
    // (optional) with that you can import your components like
    // "import Counter from '@/Counter.vue'"
    // (no need for a full path)
    "moduleNameMapper": {
        "^@/(.*)$": "<rootDir>/resources/js/$1"
    },

    "setupFilesAfterEnv": [
        "<rootDir>/resources/js/tests/setup.js"
    ],

    "testEnvironment": 'jsdom'
}