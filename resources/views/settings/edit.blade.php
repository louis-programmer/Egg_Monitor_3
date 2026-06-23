<h1>System Settings</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('settings.update') }}">
    @csrf
    @method('PUT')

    <div>
        <label>Setter Survival Rate (%)</label>
        <input type="number"
               step="0.01"
               name="preset_setter_survival_rate"
               value="{{ $setting->preset_setter_survival_rate }}">
    </div>

    <div>
        <label>Hatcher Survival Rate (%)</label>
        <input type="number"
               step="0.01"
               name="preset_hatcher_survival_rate"
               value="{{ $setting->preset_hatcher_survival_rate }}">
    </div>

    <div>
        <label>Order Buffer (%)</label>
        <input type="number"
               step="0.01"
               name="preset_order_buffer"
               value="{{ $setting->preset_order_buffer }}">
    </div>

    <div>
        <label>Setter Days</label>
        <input type="number"
               name="preset_setter_days"
               value="{{ $setting->preset_setter_days }}">
    </div>

    <div>
        <label>Hatcher Days</label>
        <input type="number"
               name="preset_hatcher_days"
               value="{{ $setting->preset_hatcher_days }}">
    </div>

    <div>
        <label>Simulation Minutes Per Day</label>
        <input type="number"
               name="simulation_minutes_per_day"
               value="{{ $setting->simulation_minutes_per_day }}">
    </div>

    <button type="submit">
        Save Settings
    </button>
</form>