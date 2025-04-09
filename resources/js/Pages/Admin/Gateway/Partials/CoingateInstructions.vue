<script setup>
import trans from "@/Composables/transComposable"
</script>

<template>
  <div class="mt-5 flex gap-2 flex-col p-1 pr-8">
    <p class="text-sm alert-info p-3 rounded-md">
      <span class="font-bold text-nowrap">{{ trans("Price Currency") }}: </span>
      <a target="_blank" class="underline" href="http://en.wikipedia.org/wiki/ISO_4217"
        >ISO 4217</a
      >
      currency code which defines the currency in which you wish to price your
      merchandise; used to define price parameter.
      <a
        target="_blank"
        class="underline"
        href="https://developer.coingate.com/docs/currencies"
        >Supported currencies</a
      >
    </p>
    <p class="text-sm alert-info p-3 rounded-md">
      <span class="font-bold text-nowrap">{{ trans("Receive Currency") }}: </span>
      <a target="_blank" class="underline" href="http://en.wikipedia.org/wiki/ISO_4217"
        >ISO 4217</a
      >
      currency code which defines the currency in which you wish to receive your
      settlements. Currency conversions are done by CoinGate. Possible values: fiat -
      <em>EUR</em>; stablecoin - <em>USDT</em>; crypto: <em>BTC</em>, <em>LTC</em>,
      <em>ETH</em> or <em>DO_NOT_CONVERT</em>. <strong>Note</strong>: use
      <em>DO_NOT_CONVERT</em> to keep payments received in original currency (Altcoin
      payments will be converted to BTC). With <em>DO_NOT_CONVERT</em> you can also extend
      invoice expiration time up to 24 hours.
      <a
        target="_blank"
        class="underline"
        href="https://developer.coingate.com/docs/currencies"
        >Supported currencies</a
      >
    </p>
  </div>
</template>
