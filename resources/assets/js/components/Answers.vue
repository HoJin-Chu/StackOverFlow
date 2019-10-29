<template>
    <div class="row mt-4" v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                    </div>
                    <hr>
                    <Answer
                    v-for="answer in answers"
                    :answer="answer"
                    :key="answer.id">
                    </Answer>

                    <div class="text-center mt-3" v-if="nextUrl">
                        <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Answer from './Answer'

export default {
    props: ['question'],
    components: {
        Answer
    },
    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null
        }
    },
    created() {
        this.fetch(`/questions/${this.questionId}/answers`)
    },
    computed: {
        title() {
            return this.count + " " + (this.count > 1 ? 'Answers' : 'Answer')
        }
    },
    methods: {
        fetch(endpoint) {
            axios.get(endpoint)
            .then(({data}) => { // data만 뽑음
                // console.log(response)
                this.answers.push(...data.data) // 배열 합치기
                this.nextUrl = data.next_page_url
            })
        }
    },
}
</script>

<style>

</style>
