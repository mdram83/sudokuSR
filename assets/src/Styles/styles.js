export const styles = {
    general: {
        svg: {
            base: {
                xmlns: "http://www.w3.org/2000/svg",
                width: 20,
                height: 20,
                viewBox: "0 0 24 24",
                fill: "none",
                'stroke': "currentColor",
                'strokeWidth': 1,
                'strokeLinecap': "round",
                'strokeLinejoin': "round",
                className: 'mt-1',
            },
        },
    },
    difficultyLevel: {
        div: {
            base: ' relative flex justify-center m-0 p-0 hover:bg-gray-300 hover:cursor-default focus:outline-none border rounded ',
            active: ' border-2 border-emerald-600 bg-emerald-100 ',
            default: ' border-gray-400 ',
        },
    },
    action: {
        div: {
            base: ' flex justify-center m-0 p-0 hover:bg-gray-300 hover:cursor-default focus:outline-none border rounded ',
            active: ' border-2 border-blue-400 text-blue-400 ',
            default: ' border-gray-400 ',
        },
    },
    messageButton: {
        div: {
            base: ' grid grid-cols-1 gap-1 w-72 h-8 my-4 p-3 border border-blue-500 rounded-xl bg-blue-500 text-sm text-white flex justify-center content-center align-center ',
            default: ' hover:cursor-default ',
            active: ' hover:cursor-pointer ',
        },
    },
}