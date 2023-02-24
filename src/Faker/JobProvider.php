<?php

namespace App\Faker;

use Faker\Provider\Base;

class JobProvider extends Base
{
	protected static $categories = ['Telecommunication', 'Garments / Textile', 'Health Care', 'Accounting / Finance', 'Education', 'Engineer & Architects', 'Customer Support', 'Design & Creative', 'Marketing & Sales', 'Digital Media', 'Software Company', 'Cloud Computing', 'Logistics/Shipping', 'Logistics/Shipping', 'Engineering Services', 'Telecom / Internet', 'Healthcare/Pharma', 'Finance/Insurance', 'Product Software', 'Diversified/Retail', 'Education', 'Banking/BPO', 'Printing & Packaging', 'Web Designing', 'Laravel Developer', 'Web Master', 'Font Developer', 'Sales Manager', 'Chat Manager', 'Team Leader', 'Product Designer', 'Pride Technologies', 'Petroleum/Energy', 'Magento Developer', 'UI/UX Designer', 'PHP Developer', 'WordPress Developer'];

	protected static $types = ['Part Time', 'Full Time', 'Freelance', 'Temporary', 'Permanent', 'COntract', 'Enternship'];

	protected static $skills = ['Senior UI / UX Designer', 'IT Junior', 'Accounting Manager', 'UI Designer', 'ios developer', 'Graphics Designer', 'Content Writer', 'Engineer', 'Leader IT engineer', 'Web Develper'];

	public function jobCategory(): string
	{
		return static::randomElement(static::$categories);
	}

	public function jobType(): string
	{
		return static::randomElement(static::$types);
	}

	public function jobSkill(): string
	{
		return static::randomElement(static::$skills);
	}
}