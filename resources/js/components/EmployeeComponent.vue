<template>
    <div class="employee">
        <h2>
            {{ employeeName }}
        </h2>
        <b-row>
            <b-col>
                <b-form-group label="Post">
                    <b-form-select
                        v-model="postId"
                        :options="posts"
                        @change="postChange"
                    >
                    </b-form-select>
                </b-form-group>
            </b-col>
            <b-col>
                <b-form-group label="Skills">
                    <b-form-checkbox-group
                        v-model="selectedSkills"
                        :options="skills"
                        @change="skillsChange"
                        :disabled="!postId"
                        switches
                    >
                    </b-form-checkbox-group>
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>

<script>

export default {
    created() {
        this.updatePosts();
        this.updateSkills();
        this.updateEmployee();
    },
    data() {
        return {
            posts: [],
            skills: [],
            employee: {},
            employeeName: '',
            postId: null,
            selectedSkills: [],
        };
    },
    methods: {
        updateEmployee() {
            let url = addApiTokenToUrl('/api/v1/employee/' + this.id);

            axios.get(url)
                .then(({ data }) => {
                    console.log(data);
                    this.employee = data.data;
                    this.employeeName = this.employee.user.name;

                    this.postId = this.employee.post ? this.employee.post.id : null;

                    this.employee.skills.forEach(employeeSkill => {
                        this.selectedSkills.push(employeeSkill.skill_id);
                    });
                })
                .catch(() => {
                    alert('Error!');
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
                    alert('Error!');
                });
        },
        updateSkills() {
            let url = addApiTokenToUrl('/api/v1/skill');

            axios.get(url)
                .then(({ data }) => {
                    this.updateSkillsFromData(data.data);
                })
                .catch(() => {
                    alert('Error!');
                });
        },
        updateSkillsFromData(data) {
            this.skills = [];

            data.forEach(element => {
                this.skills.push(
                    { value: element.id, text: element.title },
                );
            });
        },
        postChange() {
            let url = addApiTokenToUrl(`/api/v1/employee-post/${this.id}/update`);

            axios.patch(url, {
                'post_id': this.postId ? this.postId : 0,
            })
            .then(({ data }) => {})
            .catch(() => {
                alert('Error!');
            });

        },
        skillsChange() {
            let url = addApiTokenToUrl(`/api/v1/employee-skills/${this.id}/update`);

            axios.patch(url, {
                'skill_ids': this.selectedSkills,
            })
            .then(({ data }) => {
                this.updateSkillsFromData(data.data);
            })
            .catch(() => {
                alert('Error!');
            });
        }

    },
    props: {
        id: {
            required: true
        },
    }
};
</script>
