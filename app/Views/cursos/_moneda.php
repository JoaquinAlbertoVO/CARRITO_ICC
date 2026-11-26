<?php /* Selector Soles / Dolares; necesita un x-data con "moneda" en un contenedor. */ ?>
<div class="inline-flex rounded-full bg-white p-1 shadow-sm ring-1 ring-line/60" role="group" aria-label="Moneda de los precios">
    <button type="button" @click="moneda = 'PEN'" :aria-pressed="moneda === 'PEN'" :class="moneda === 'PEN' ? 'bg-brand text-white shadow' : 'text-muted hover:text-deep'" class="min-h-[40px] rounded-full px-5 text-sm font-bold">Soles (S/)</button>
    <button type="button" @click="moneda = 'USD'" :aria-pressed="moneda === 'USD'" :class="moneda === 'USD' ? 'bg-brand text-white shadow' : 'text-muted hover:text-deep'" class="min-h-[40px] rounded-full px-5 text-sm font-bold">Dólares (US$)</button>
</div>
