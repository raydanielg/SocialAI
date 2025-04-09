"use strict";
let loaderPercentage = 0
const startTime = performance.now()
const time = 2000

function getLoadingPercentage() {
  const elapsedTime = performance.now() - startTime
  const loadingPercentage = (elapsedTime / time) * 100
  return Math.min(loadingPercentage, 100)
}

const intervalId = setInterval(() => {
  loaderPercentage = Math.round(getLoadingPercentage())
  updateLoaderDisplay()
  if (loaderPercentage === 100) {
    clearInterval(intervalId)
    setTimeout(() => {
      hideLoader()
    }, 200)
  }
}, 100)

function updateLoaderDisplay() {
  const loaderElement = document.getElementById('loader')
  const loaderText = document.getElementById('loader-text')
  if (loaderElement) {
    loaderElement.style.width = `${loaderPercentage}%`
    loaderText.textContent = `${loaderPercentage}%`
  }
}

function hideLoader() {
  const loaderElement = document.getElementById('loader')
  const loaderContainer = document.getElementById('loader-container')
  if (loaderElement) {
    loaderElement.style.display = 'none'
    loaderContainer.style.display = 'none'
  }
}
