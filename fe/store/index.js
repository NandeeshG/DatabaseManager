export const state = () => ({
  students: [],
  teachers: [],
  currStudent: {},
  currTeacher: {},
})

export const mutations = {
  addStudent(state) {
    if (
      state.currStudent === null ||
      state.currStudent === undefined ||
      state.currStudent === {}
    )
      throw new Error('Problem adding student (empty value)')
    state.students.forEach((element) => {
      if (element === state.currStudent)
        throw new Error('Student already present!')
    })
    state.students.push(state.currStudent)
  },
  currStudentUpd(state, cs) {
    state.currStudent = cs
  },
}
