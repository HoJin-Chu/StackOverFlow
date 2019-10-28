<template>
    <div>


    </div>
</template>

<script>
export default {
    props: ['answer'],
    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 10;
        },

        endpoint() {
            return `/questions/${this.questionId}/answers/${this.id}`
        }
    },

    methods: {
        edit() {
            this.beforeEditCache = this.body
            this.editing = true
        },
        cancel() {
            this.body = this.beforeEditCache
            this.editing = false
        },
        update() {
            axios.patch(this.endpoint, {
                body: this.body
            })
            .then(response => {
                this.editing = false
                this.bodyHtml = response.data.body_html
                alert(response.data.message)
            })
            .catch(error => {
                alert(error.response.data.message)
            })
        },
        destroy() {
            if(confirm('Are you sure')) {
                axios.delete(this.endpoint)
                .then(response => {
                    $(this.$el).fadeOut(500, () => {
                        alert(response.data.message)
                    })
                })
            }
        },
    },
}
</script>
