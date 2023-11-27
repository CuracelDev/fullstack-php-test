module.exports = {
    moduleFileExtensions: ['js', 'jsx', 'json', 'vue'],
    transform: {
      '^.+\\.vue$': 'vue-jest',
      '^.+\\.jsx?$': 'babel-jest',
      '^.+\\.js?$': 'babel-jest',
    },
    moduleNameMapper: {
      '^@/(.*)$': '<rootDir>/resources/js/$1',
      '^vue$': 'vue/dist/vue.runtime.common.js',
    },
    snapshotSerializers: ['jest-serializer-vue'],
    testEnvironment: 'jsdom',
    testMatch: ['<rootDir>/resources/js/tests/**/*.spec.(js|jsx|ts|tsx)|**/__tests__/*.(js|jsx|ts|tsx)']
  };