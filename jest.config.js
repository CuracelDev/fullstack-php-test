module.exports = {
    testEnvironment: 'jsdom',
    roots: ['<rootDir>/resources/js/specs'],
    moduleFileExtensions: [
      'js',
      'json',
      // Tell Jest to handle `*.vue` files
      'vue'
    ],
    transform: {
      // Process `*.vue` files with `vue-jest`
      '^.+\\.vue$': 'vue-jest',
      // Process js files with `babel-jest`
      '^.+\\.js$': 'babel-jest'
    },
    moduleNameMapper: {
      // Handle CSS imports in Vue components
      // (https://jestjs.io/docs/webpack#handling-static-assets)
      '\\.(css|less|scss|sass)$': 'identity-obj-proxy'
    },
    testPathIgnorePatterns: [
      '/node_modules/',
      '/vendor/',
      '/public/'
    ]
  };

