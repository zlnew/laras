module.exports = {
    "env": {
        "browser": true,
        "es2021": true
    },
    "extends": [
        "standard-with-typescript",
        "plugin:vue/vue3-essential"
    ],
    "overrides": [
        {
            "env": {
                "node": true
            },
            "files": [
                ".eslintrc.{js,cjs}", ".vite.config.js",
            ],
            "parserOptions": {
                "sourceType": "script",
            }
        }
    ],
    "parserOptions": {
        "ecmaVersion": "latest",
        "sourceType": "module",
        "tsconfigRootDir": __dirname,
        "project": ['./tsconfig.json'],
        "parser": require.resolve('@typescript-eslint/parser'),
        "extraFileExtensions": [ '.vue' ]
    },
    "plugins": [
        "vue"
    ],
    "ignorePatterns": ["vendor/**/*.js", "vendor/**/*.vue", "vendor/**/*.ts"],
    "rules": {
        'generator-star-spacing': 'off',
        'arrow-parens': 'off',
        'one-var': 'off',
        'no-void': 'off',
        'multiline-ternary': 'off',
        'import/first': 'off',
        'import/namespace': 'error',
        'import/default': 'error',
        'import/export': 'error',
        'import/extensions': 'off',
        'import/no-unresolved': 'off',
        'import/no-extraneous-dependencies': 'off',
        'import/named': 'off',        
        'prefer-promise-reject-errors': 'off',
        'quotes': ['warn', 'single', { avoidEscape: true }],
        '@typescript-eslint/explicit-function-return-type': 'off',
        '@typescript-eslint/no-var-requires': 'off',
        'no-unused-vars': 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off'
    }
}
