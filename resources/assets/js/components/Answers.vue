<template>
    <div>
        <div class="row mt-4" v-cloak v-if="count">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{ title }}</h2>
                        </div>
                        <hr>
                        <Answer
                        @deleted="remove(index)"
                        v-for="(answer, index) in answers"
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
        <NewAnswer @created="add" :questionId="question.id"></NewAnswer>
    </div>

</template>

<script>
import Answer from './Answer'
import NewAnswer from './NewAnswer'
import highlight from '../mixin/highlight'

export default {
    props: ['question'],
    mixins: [highlight],
    components: {
        Answer,
        NewAnswer
    },
    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            answerIds: [],
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
            this.answerIds = []
            axios.get(endpoint)
            .then(({data}) => { // data만 뽑음
                // console.log(response)
                this.answerIds = data.data.map(a => a.id)
                this.answers.push(...data.data) // 배열 합치기
                this.nextUrl = data.next_page_url
            })
            .then(() => {
                this.answerIds.forEach(id => {
                    this.highlight(`answer-${id}`)
                })
            })
        },
        remove(index) {
            this.answers.splice(index, 1)
            this.count--
        },
        add(answer) {
            this.answers.push(answer)
            this.count++
            this.$nextTick(() => {
                this.highlight(`answer-${answer.id}`)
            })
        }
    },
}
</script>

<style>

</style>
