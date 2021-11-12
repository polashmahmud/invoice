<template>
    <div>
        <PageHeader :title="title" :items="items" />
    </div>
</template>

<script>
/**
 * Dashboard component
 */
export default {
    head() {
        return {
            title: `${this.title} | Nuxtjs Responsive Bootstrap 5 Admin Dashboard`,
        };
    },
    data() {
        return {
            title: "Dashboard",
            items: [{
                    text: "Minible",
                },
                {
                    text: "Dashboard",
                    active: true,
                },
            ],
        };
    }
};
</script>

<style></style>
