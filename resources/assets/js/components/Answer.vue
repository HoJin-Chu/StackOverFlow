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
                this.$toast.success(response.data.message, "Success", {timeout: 3000})
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, "Error", {timeout: 3000})
            })
        },
        destroy() {
            this.$toast.question('정말 삭제하시겠어요?', "답글,", {
                timeout: 5000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>네</b></button>', (instance, toast) => {
                        axios.delete(this.endpoint)
                        .then(response => {
                            $(this.$el).fadeOut(200, () => {
                                this.$toast.success(response.data.message, "Success", {timeout: 3000})
                            })
                        })
                        instance.hide({ transitionOut: 'flipOutX' }, toast, 'button');

                    }, true],
                    ['<button>아니요</button>', (instance, toast) => {
                        instance.hide({ transitionOut: 'fadeOutRight' }, toast, 'button');
                    }],
                ],
            });

        },
    },
}
</script>