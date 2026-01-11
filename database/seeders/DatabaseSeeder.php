<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Owner;
use App\Models\Tenant;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Subunit;
use App\Models\Contract;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);
        
        Auth::login($admin);

        // Owners
        $owner1 = Owner::create(['name' => 'Ahmed Ali', 'email' => 'ahmed@test.com', 'phone' => '0501234567', 'emirates_id' => '784-1234-1234567-1', 'nationality' => 'UAE', 'address' => 'Dubai Marina']);
        $owner2 = Owner::create(['name' => 'Fatima Hassan', 'email' => 'fatima@test.com', 'phone' => '0507654321', 'emirates_id' => '784-5678-7654321-2', 'nationality' => 'UAE', 'address' => 'JBR']);

        // Tenants
        $tenant1 = Tenant::create(['name' => 'John Smith', 'email' => 'john@test.com', 'phone' => '0509876543', 'passport_no' => 'US123456', 'nationality' => 'USA', 'address' => 'Business Bay']);
        $tenant2 = Tenant::create(['name' => 'Maria Garcia', 'email' => 'maria@test.com', 'phone' => '0503456789', 'passport_no' => 'ES987654', 'nationality' => 'Spain', 'address' => 'Downtown Dubai']);

        // Buildings
        $building1 = Building::create(['owner_id' => $owner1->id, 'building_name' => 'Marina Heights', 'address' => 'Marina Walk', 'city' => 'Dubai', 'status' => 'occupied']);
        $building2 = Building::create(['owner_id' => $owner2->id, 'building_name' => 'Sky Tower', 'address' => 'Sheikh Zayed Road', 'city' => 'Dubai', 'status' => 'occupied']);

        // Units
        $unit1 = Unit::create(['building_id' => $building1->id, 'unit_no' => '1205', 'floor_no' => '12', 'area_sqft' => 1200, 'assets' => ['AC', 'Fridge', 'Washing Machine'], 'status' => 'occupied']);
        $unit2 = Unit::create(['building_id' => $building1->id, 'unit_no' => '805', 'floor_no' => '8', 'area_sqft' => 800, 'assets' => ['AC'], 'status' => 'occupied']);
        $unit3 = Unit::create(['building_id' => $building2->id, 'unit_no' => '305', 'floor_no' => '3', 'area_sqft' => 1500, 'assets' => ['AC', 'Fridge', 'Bed'], 'status' => 'vacant']);

        // Subunits
        $sub1 = Subunit::create(['unit_id' => $unit1->id, 'subunit_no' => 'R1', 'subunit_type' => 'room', 'area_sqft' => 400, 'status' => 'occupied']);
        $sub2 = Subunit::create(['unit_id' => $unit1->id, 'subunit_no' => 'R2', 'subunit_type' => 'room', 'area_sqft' => 350, 'status' => 'vacant']);
        $sub3 = Subunit::create(['unit_id' => $unit2->id, 'subunit_no' => 'R1', 'subunit_type' => 'room', 'area_sqft' => 400, 'status' => 'occupied']);

        // Owner Contracts
        $ownerContract1 = Contract::create([
            'unit_id' => $unit1->id,
            'person_id' => $owner1->id,
            'contract_type' => 'owner',
            'contract_number' => 'OC-2024-001',
            'ejari_no' => 'EJ-001-2024',
            'start_date' => '2024-01-01',
            'end_date' => '2025-01-01',
            'duration_months' => 12,
            'total_amount' => 120000,
            'status' => 'active',
            'notes' => 'Annual maintenance included'
        ]);

        $ownerContract2 = Contract::create([
            'unit_id' => $unit2->id,
            'person_id' => $owner1->id,
            'contract_type' => 'owner',
            'contract_number' => 'OC-2024-002',
            'ejari_no' => 'EJ-002-2024',
            'start_date' => '2024-03-01',
            'end_date' => '2025-03-01',
            'duration_months' => 12,
            'total_amount' => 80000,
            'status' => 'active'
        ]);

        // Tenant Contracts
        $tenantContract1 = Contract::create([
            'unit_id' => $unit1->id,
            'person_id' => $tenant1->id,
            'contract_type' => 'tenant',
            'contract_number' => 'TC-2024-001',
            'ejari_no' => 'EJ-T001-2024',
            'start_date' => '2024-01-15',
            'end_date' => '2025-01-15',
            'duration_months' => 12,
            'total_amount' => 95000,
            'status' => 'active',
            'notes' => 'Includes parking'
        ]);
        $tenantContract1->subunits()->attach($sub1->id);

        $tenantContract2 = Contract::create([
            'unit_id' => $unit2->id,
            'person_id' => $tenant2->id,
            'contract_type' => 'tenant',
            'contract_number' => 'TC-2024-002',
            'ejari_no' => 'EJ-T002-2024',
            'start_date' => '2024-02-01',
            'end_date' => '2025-02-01',
            'duration_months' => 12,
            'total_amount' => 65000,
            'status' => 'active'
        ]);
        $tenantContract2->subunits()->attach($sub3->id);

        // Payments for contracts
        Payment::create(['contract_id' => $ownerContract1->id, 'payment_type' => 'cheque', 'payment_number' => 'CHQ-001', 'bank_name' => 'Emirates NBD', 'amount' => 30000, 'due_date' => '2024-01-01', 'status' => 'cleared']);
        Payment::create(['contract_id' => $ownerContract1->id, 'payment_type' => 'cheque', 'payment_number' => 'CHQ-002', 'bank_name' => 'Emirates NBD', 'amount' => 30000, 'due_date' => '2024-04-01', 'status' => 'cleared']);
        Payment::create(['contract_id' => $ownerContract1->id, 'payment_type' => 'online', 'amount' => 30000, 'due_date' => '2024-07-01', 'status' => 'collected']);
        Payment::create(['contract_id' => $ownerContract1->id, 'payment_type' => 'cash', 'amount' => 30000, 'due_date' => '2024-10-01', 'status' => 'pending']);

        Payment::create(['contract_id' => $tenantContract1->id, 'payment_type' => 'cheque', 'payment_number' => 'CHQ-101', 'bank_name' => 'ADCB', 'amount' => 47500, 'due_date' => '2024-01-15', 'status' => 'cleared']);
        Payment::create(['contract_id' => $tenantContract1->id, 'payment_type' => 'cheque', 'payment_number' => 'CHQ-102', 'bank_name' => 'ADCB', 'amount' => 47500, 'due_date' => '2024-07-15', 'status' => 'pending']);

        Payment::create(['contract_id' => $tenantContract2->id, 'payment_type' => 'online', 'amount' => 65000, 'due_date' => '2024-02-01', 'status' => 'cleared']);
        
        Auth::logout();
    }
}