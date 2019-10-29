<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="10" placeholder="10자 이상 작성해야합니다" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">수정</button>
                <button class="btn btn-outline-secondary"
                @click="cancel" type="button"
                >취소</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">수정</a>
                            <button v-if="authorize('modify', answer)"  @click="destroy" class="btn btn-sm btn-outline-danger">삭제</button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info
                        :model = "answer"
                        label = "Answered"
                        ></user-info>
                    </div>
                </div>
            </div>
        </div>
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
                            this.$emit('deleted')
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
