<template>
    <div class="employees-table">
        <div>
            <div id="head-table-employees">
                <b-row>
                    <b-col class="text-right">
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="total"
                            :per-page="perPage"
                            aria-controls="my-table"
                        >
                        </b-pagination>
                    </b-col>
                    <b-col class="text-left" v-if="! onlyPublicInfo">
                        <b-form-select
                            v-model="selectedSorting"
                            :options="sortingOptions"
                            @change="sortingOptionsChange"
                        >
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row v-if="! onlyPublicInfo">
                    <b-input-group>
                        <b-form-input
                            v-model="filterText"
                            placeholder="Enter search text for name, email, posts, skills."
                        >
                        </b-form-input>
                        <b-form-select
                            v-model="selectedPost"
                            :options="posts"
                        >
                        </b-form-select>
                        <b-form-select
                            v-model="selectedSkill"
                            :options="skills"
                        >
                        </b-form-select>
                        <b-button
                            variant="outline-danger"
                            @click="resetFilter"
                        >
                            Reset
                        </b-button>
                        <b-button
                            variant="outline-primary"
                            @click="applyFilter"
                        >
                            Apply
                        </b-button>
                    </b-input-group>
                </b-row>
            </div>
            <b-table
                :bordered="true"
                :borderless="false"
                :items="items"
            >
                <template #cell(id)="data">
                    {{ data.item.id }}
                </template>
                <template #cell(user)="data">
                    <div v-if="thereIsAdminRole">
                        <a v-bind:href="makeLinkEmployeeEditor(data.item)">
                            <div>
                                {{ data.item.user.name }}
                            </div>
                            <div>
                                {{ data.item.user.email }}
                            </div>
                            <div>
                                {{ data.item.user.phone_number }}
                            </div>
                        </a>
                    </div>
                    <div v-else>
                        <div>
                            {{ data.item.user.name }}
                        </div>
                        <div>
                            {{ data.item.user.email }}
                        </div>
                        <div>
                            {{ data.item.user.phone_number }}
                        </div>
                    </div>
                </template>
                <template #cell(post)="data">
                    {{ data.item.post ? data.item.post.title : '' }}
                </template>
                <template #cell(skills)="data">
                    <div v-for="skill in data.item.skills" :key="skill.id">
                        {{ skill.skill.title }}
                    </div>
                </template>
                <template #cell(is_admin)="data" v-if="thereIsAdminRole">
                    <b-form-checkbox
                        v-model="data.item.is_admin"
                        name="check-button"
                        @change="isAdminChange(data.item)"
                        switch
                    >
                    </b-form-checkbox>
                </template>
            </b-table>
        </div>
    </div>
</template>

<script>

export default {
    components: {
    },
    created() {
        this.selectedSorting = this.sortingOptions[0].value;

        if (! this.onlyPublicInfo) {
            this.url = 'api/v1/employee';
        } else {
            this.url = 'api/v1/employee-public-info';
        }

        this.updateTable();

        if (! this.onlyPublicInfo) {
            this.updatePosts();
            this.updateSkills();
        }
    },
    data() {
        return {
            thereIsAdminRole: (this.parThereIsAdminRole === '1'),
            onlyPublicInfo: (this.parOnlyPublicInfo === 'true'),
            url: '',
            isBusy: false,
            items: [],
            currentPage: 1,
            total: 0,
            perPage: 0,
            selectedSorting: null,
            sortingOptions: [
                { value: null, text: 'Please select an sorting' },
                { value: 'users.name|asc', text: 'Sort by user (asc)' },
                { value: 'users.name|desc', text: 'Sort by user (desc)'},
                { value: 'employees.created_at|asc', text: 'Sort by created at (asc)' },
                { value: 'employees.created_at|desc', text: 'Sort by created at (desc)' },
            ],
            filterOn: false,
            filterText: '',
            selectedPost: null,
            posts: [],
            selectedSkill: null,
            skills: [],
        };
    },
    computed: {

    },
    methods: {
        makeLinkEmployeeEditor(item) {
            return '/employee-editor/' + item.id;
        },
        updateTable(page = 1) {
            let url = this.url + '?page=' + page;

            if (this.selectedSorting) {
                url += '&sort_by=' + this.selectedSorting;
            }

            if (this.filterOn) {
                if (this.filterText) {
                    url += '&filter_text=' + this.filterText;
                }
                if (this.selectedPost) {
                    url += '&post_id=' + this.selectedPost;
                }
                if (this.selectedSkill) {
                    url += '&skill_id=' + this.selectedSkill;
                }
            }

            if (! this.onlyPublicInfo) {
                url = addApiTokenToUrl(url, '&');
            }

            axios.get(url)
                .then(({ data }) => {
                    this.items = data.data;
                    this.total = data.meta.total
                    this.perPage = data.meta.per_page
                })
                .catch(() => {
                    this.items = [];
                });

        },
        isAdminChange(item) {
            let url = addApiTokenToUrl(`api/v1/user-role/${item.user.id}/is-admin`);

            axios.patch(url, {
                'is_admin': item.is_admin,
            })
            .then(({ data }) => {})
            .catch(() => {
                item.is_admin = !item.is_admin;
            });
        },
        updatePosts() {
            this.posts = [
                { value: null, text: 'Please select an post' },
            ];

            let url = addApiTokenToUrl('/api/v1/post');

            axios.get(url)
                .then(({ data }) => {
                    data.data.forEach(element => {
                        this.posts.push(
                            { value: element.id, text: element.title },
                        );
                    });
                })
                .catch(() => {
                    this.posts = [];
                });
        },
        updateSkills() {
            this.skills = [
                { value: null, text: 'Please select an skill' },
            ];

            let url = addApiTokenToUrl('/api/v1/skill');

            axios.get(url)
                .then(({ data }) => {
                    data.data.forEach(element => {
                        this.skills.push(
                            { value: element.id, text: element.title },
                        );
                    });
                })
                .catch(() => {
                    this.skills = [];
                });
        },
        sortingOptionsChange() {
            this.updateTable();
        },
        resetFilter() {
            this.filterText = '';
            this.selectedPost = null;
            this.selectedSkill = null;

            if (! this.filterOn) {
                return;
            }

            this.filterOn = false;

            this.updateTable();
        },
        applyFilter() {
            this.filterOn = true;
            this.updateTable();
        },
    },
    watch: {
        currentPage: {
            handler: function(value) {
                this.updateTable(value);
            }
        },
    },
    props: {
        parThereIsAdminRole: {
            required: true
        },
        parOnlyPublicInfo: {
            required: true
        }
    }
};
</script>

<style>
    #head-table-employees {
        padding-bottom: 10px;
    }
</style>