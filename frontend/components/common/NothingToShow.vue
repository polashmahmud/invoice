<template>
    <div class="text-center" :class="`mt-${marginTop} mb-${marginBottom}`">
        <svg
            width="87"
            height="99"
            viewBox="0 0 87 99"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <g>
                <path
                    d="M44.6133 48.4331V61.1876C44.6133 62.0786 45.1853 62.8678 46.0323 63.1483C46.244 63.2171 46.4613 63.2501 46.6758 63.2501C47.3193 63.2501 47.9408 62.9476 48.3368 62.4086L55.7975 52.2556L44.6133 48.4331Z"
                    fill="#ABAFB4"
                />
                <path
                    d="M85.6847 0.381517C85.0522 -0.0667329 84.2217 -0.127233 83.5342 0.233017L21.6592 32.5455C20.9277 32.9278 20.4959 33.7088 20.5564 34.531C20.6197 35.356 21.1669 36.06 21.9452 36.3268L39.1464 42.2063L75.7792 10.8838L47.4322 45.036L76.2604 54.8893C76.4749 54.9608 76.7004 54.9993 76.9259 54.9993C77.2999 54.9993 77.6712 54.8975 77.9984 54.6995C78.5209 54.3805 78.8757 53.8443 78.9664 53.242L86.5289 2.36702C86.6417 1.59702 86.3172 0.832517 85.6847 0.381517Z"
                    fill="#ABAFB4"
                />
            </g>
            <path
                d="M3.0547 96.9999C-0.941772 84.5003 35.0547 87.4995 23.6287 76.5527C18.6139 71.7482 13.0677 82.2701 17.5547 86.9995C26.8126 96.7577 39.8247 80.5416 44.3564 65.9999"
                stroke="#ABAFB4"
                stroke-width="3"
                stroke-linecap="round"
            />
            <defs>
                <clipPath id="clip0">
                    <rect
                        width="66"
                        height="66"
                        fill="white"
                        transform="translate(20.5508)"
                    />
                </clipPath>
            </defs>
        </svg>
        <p>You have nothing to show</p>
    </div>
</template>

<script>
export default {
    name: "NothingToShow",
    props: {
        marginTop: {
            type: String,
            default: "9"
        },
        marginBottom: {
            type: String,
            default: "0"
        }
    }
};
</script>

<style scoped></style>