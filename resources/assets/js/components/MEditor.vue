<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" :href="tabId('write', '#')">Write</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="tabId('preview', '#')">preview</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="tab-pane active" :id="tabId('write')">
                <slot></slot>
            </div>
            <div class="tab-pane" v-html="preview" :id="tabId('preview')"></div>
        </div>
    </div>
</template>

<script>
import MarkdownIt from 'markdown-it'
import prism from 'markdown-it-prism'
import autosize from 'autosize'
import "prismjs/components/prism-java"
import "prismjs/components/prism-python"

const md = new Ma`rkdownIt()
md.use(prism)

export default {
    props: ['body', 'name'],
    computed: {
        preview() {
            return md.render(this.body)
        }
    },
    methods: {
        tabId(tabName, hash = '') {
            return `${hash}${tabName}${this.name}`
        }
    },
    updated() {
        autosize(document.querySelector('textarea'))
    }
}
</script>

<style>

</style>
