module.exports = {
    "env": {
        "browser": true,
        "es6": true
    },
    "extends": [
        "plugin:vue/strongly-recommended"
    ],
    "parserOptions": {
        "parser": "babel-eslint",
        "ecmaVersion": 2016,
        "sourceType": "module"
    },
    "rules": {
        "vue/html-indent": ["error", 4],
        "indent": [
            "error",
            4
        ],
        "linebreak-style": [
            "error",
            "unix"
        ],
        "quotes": [
            "error",
            "single"
        ],
        "semi": [
            "error",
            "always"
        ]
    },
};