const capitalize = (s) => s && s.length > 0 && s[0].toUpperCase() + s.slice(1)

const reverse = (s) => s && s.split``.reverse().join``

export default {
    capitalize,
    reverse
}
