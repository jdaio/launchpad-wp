module.exports = {
    root: true,
    env: {
        amd: true,
        browser: true,
        commonjs: true,
        es6: true,
        node: true
    },
    extends: 'airbnb-base',
    parserOptions: {
        sourceType: 'module'
    },
    plugins: ['import'],
    rules: {
        indent: ['error', 4]
    }
};
