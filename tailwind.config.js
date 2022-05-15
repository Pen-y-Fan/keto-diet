const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            },
        },
        gridTemplateColumns: {
            none: 'none',
            '1': 'repeat(1, minmax(0, 1fr))',
            '2': 'repeat(2, minmax(0, 1fr))',
            '3': 'repeat(3, minmax(0, 1fr))',
            '4': 'repeat(4, minmax(0, 1fr))',
            '5': 'repeat(5, minmax(0, 1fr))',
            '6': 'repeat(6, minmax(0, 1fr))',
            '7': 'repeat(7, minmax(0, 1fr))',
            '8': 'repeat(8, minmax(0, 1fr))',
            '9': 'repeat(9, minmax(0, 1fr))',
            '10': 'repeat(10, minmax(0, 1fr))',
            '11': 'repeat(11, minmax(0, 1fr))',
            '12': 'repeat(12, minmax(0, 1fr))',
            '34': 'repeat(34, minmax(0, 1fr))',
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
