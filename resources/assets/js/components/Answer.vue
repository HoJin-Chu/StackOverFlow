<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-show="authorize('modify', answer) && editing" @submit.prevent="update">
                <div class="form-group">
                    <m-editor :body="body" :name="uniqueName">
                        <textarea class="form-control" v-model="body" rows="10" placeholder="10자 이상 작성해야합니다" required></textarea>
                    </m-editor>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">수정</button>
                <button class="btn btn-outline-secondary"
                @click="cancel" type="button"
                >취소</button>
            </form>
            <div v-show="!editing">
                <div :id="uniqueName" v-html="bodyHtml" ref="bodyHtml"></div>
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
import modification from '../mixin/modification'

export default {
    props: ['answer'],
    mixins: [modification],
    data() {
        return {
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
        },
        uniqueName() {
            return `answer-${this.id}`
        }
    },

    methods: {
        setEditCache() {
            this.beforeEditCache = this.body
        },
        restoreFromCache() {
            this.body = this.beforeEditCache
        },
        payload() {
            return {
                body: this.body
            }
        },
        delete() {
            axios.delete(this.endpoint)
            .then(response => {
                this.$toast.success(response.data.message, "Success", {timeout:2000})
                this.$emit('deleted')
            })
        }
    },
}
</script>
