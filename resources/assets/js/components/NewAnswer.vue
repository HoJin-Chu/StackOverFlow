<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                        <!-- csrf 부트스르랩도트에서 처리 -->
                        <div class="form-group">
                            <m-editor :body="body" name="new-answer">
                                <textarea v-model="body" class="form-control" name="body" rows="7" placeholder="10자 이상" required></textarea>
                            </m-editor>
                        </div>
                        <div class="form-group">
                            <button type="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MEditor from './MEditor'

export default {
    props: ['questionId'],
    components: { MEditor },
    data() {
        return {
            body: ''
        }
    },
    computed: {
        isInvalid() {
            return !this.signedIn || this.body.length < 10
        }
    },
    methods: {
        create() {
            axios.post(`/questions/${this.questionId}/answers`, {
                body: this.body
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, "Error")
            })
            .then(({data}) => {
                this.$toast.success(data.message, "Success")
                this.body = ''
                this.$emit('created', data.answer)
            })
        }
    },
}
</script>

<style>

</style>
