<script setup>
import WelcomeItem from './WelcomeItem.vue'
import DocumentationIcon from './icons/IconDocumentation.vue'
import ToolingIcon from './icons/IconTooling.vue'
import EcosystemIcon from './icons/IconEcosystem.vue'
import CommunityIcon from './icons/IconCommunity.vue'
import SupportIcon from './icons/IconSupport.vue'
import { Button } from 'primevue'
const openReadmeInEditor = () => fetch('/__open-in-editor?file=README.md')
</script>

<template>
  <div>
    <p>This a list of routes</p>
    <Button>
      <Router-link to="/dashboard"> Register Dashboard</Router-link>
    </Button>
    <Button>
      <Router-link to="/login">Login</Router-link>
    </Button>
    <Button>
      <Router-link to="/login">Register</Router-link>
    </Button>
    <Button>
      <Router-link to="/dashboard/lecturer">Lecturer</Router-link>
    </Button>
    <Button>
      <Router-link to="/class/setup">Attendance</Router-link>
    </Button>
  </div>
</template>
