/** @type {import('tailwindcss').Config} */
export default {
    content: ['./src/**/*.{js,jsx,ts,tsx,vue}'],
    theme: {
        extend: {},
    },
    plugins: [],
    safelist: [
        {
            pattern: /bg-(gray|red|blue|green|orange|yellow|purple|pink|indigo|teal)-(50|100|200|300|400|500|600|700|800|900|950)/,
        },
        {
            pattern: /border-(gray|red|blue|green|orange|yellow|purple|pink|indigo|teal)-(50|100|200|300|400|500|600|700|800|900|950)/,
        },
        {
            pattern: /text-(gray|red|blue|green|orange|yellow|purple|pink|indigo|teal)-(50|100|200|300|400|500|600|700|800|900|950)/,
        }
    ]
};