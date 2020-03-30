module.exports = {
    env: {
        commonjs: true,
        es6: true
    },
    extends: 'airbnb',
    parserOptions: {
        sourceType: 'module'
    },
    plugins: ['import', 'prettier'],
    root: true,
    rules: {
        indent: ['error', 4]
    }
};
