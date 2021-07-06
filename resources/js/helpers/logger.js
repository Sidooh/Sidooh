/* eslint-disable no-console */

const {isProduction} = require("../constants");

exports.log = (message, ...args) => {
    if (!isProduction) console.log(message, args)
}

exports.error = (err) => {
    if (!isProduction) console.error(err)
}
