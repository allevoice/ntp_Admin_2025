<?php


namespace App\Model;


class Service extends Mainmodel
{


    protected   $table = "services";
    protected   $id;
    protected   $title;
    protected   $leveld;
    protected   $content;
    protected   $statuts;
    protected   $iduser;
    protected   $created_at;
    protected   $updated_at;
    protected   $deleted_at;


    protected $sql_queries;







    public function service_info(){

        $data = [
            'id'=>'1',
            'title'=>'Services',
//            'content'=>'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
            'content'=>'',
//            'subtitle'=>'Professional Services',
            'subtitle'=>'',
            'title_sub'=>'Elevating Business Performance Through Strategic Solutions ',
            'content_sub'=>'In today’s competitive market, businesses need more than just operational efficiency—they need strategic solutions that drive growth, innovation, and long-term success. Our approach focuses on understanding your unique challenges, identifying opportunities, and implementing solutions that maximize performance across all areas of your organization. ',
            'img'=>'services-9.webp',
        ];



        return $data;








    }

    public function liste_service_array_info(){
        $data = [

            [
                'id'=>'1',
                'title'=>'Elevating Business Performance Through Strategic Solutions',
                'link_ebook'=>'https://book.squareup.com/appointments/7jwdcckk8siagh/location/LGJ2PB5YW3M0K/services',
                'idlst'=>'',
                'icon'=>'',
                'content'=>'',

                'description'=>'

                 <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5>Business Strategy & Planning </h5>
                        <p>
                       We help organizations define clear goals, create actionable roadmaps, and align resources to ensure strategic initiatives deliver measurable results.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5>Process Optimization </h5>
                        <p>
                        Through analysis and re-engineering of business processes, we eliminate inefficiencies, reduce costs, and enhance productivity across departments.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5>Technology & Digital Solutions </h5>
                        <p>
                        We leverage cutting-edge technology and digital tools to streamline operations, improve decision-making, and enable data-driven growth.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5>Risk Management & Compliance</h5>
                        <p>
                       Our strategic solutions include identifying potential risks, implementing controls, and ensuring compliance with industry regulations to protect your business assets.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h5>Performance Monitoring & Analytics</h5>
                        <p>
                        We use KPIs, dashboards, and advanced analytics to track performance, measure success, and provide insights that support continuous improvement.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h5>Talent & Organizational Development</h5>
                        <p>
                         We help build strong teams and effective leadership by aligning talent strategy with business objectives, fostering a culture of innovation and accountability.
                        </p>
                    </div>
                </div>



               <div class="features-included">
                    <h4>Why Choose Our Strategic Solutions</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Tailored strategies aligned with your business vision and objectives.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Proven methodologies to enhance efficiency, growth, and competitiveness.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Expert guidance from industry professionals with a track record of success.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Holistic approach combining strategy, technology, and people for sustainable performance.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Features -->
                </div>

                <p>
                If you want, I can also <b>create a shorter, punchy version</b> suitable for a <b>homepage banner or executive summary</b> that immediately captures attention. Do you want me to do that?
</p>








                ',
            ],

        ];





        return $data;
    }

    public function liste_service_array(){
        $data = [


            [
                'id'=>'8',
                'idlst'=>'6',
                'icon'=>'bi bi-gear-fill',
                'title'=>'Help Desk Support',
                'link_ebook'=>'https://book.squareup.com/appointments/7jwdcckk8siagh/location/LGJ2PB5YW3M0K/services/VTNAOB4NNDWVWRK3T5B6R6KX',
                'content'=>'Efficient and reliable Help Desk Support is essential for keeping your business operations running smoothly. Our services provide quick resolution to IT issues, reduce downtime, and ensure your employees and customers receive timely assistance.',
                'description'=>'
                 <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5>24/7 Technical Support</h5>
                        <p>
                        We offer round-the-clock support for hardware, software, and
                        network issues. Our team ensures problems are addressed promptly
                        to minimize disruptions and maintain productivity.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5>Multi-Channel Support</h5>
                        <p>
                        Our help desk is accessible via phone, email, live chat, or
                        ticketing system, providing flexible and convenient ways for
                        users to report and resolve issues.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5>Incident Management</h5>
                        <p>
                        We track, prioritize, and resolve IT incidents efficiently. Our
                        systematic approach ensures critical issues are handled quickly, reducing
                        operational downtime.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5>Remote Troubleshooting & Assistance</h5>
                        <p>
                        Our experts can diagnose and resolve technical problems
                        remotely, saving time and costs associated with on-site visits
                        while providing effective solutions.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h5>Knowledge Base & Self-Service</h5>
                        <p>
                        We create and maintain comprehensive knowledge bases, FAQs, and
                        self-service portals to empower users to find solutions
                        quickly and independently.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h5>Proactive Monitoring & Maintenance</h5>
                        <p>
                         Beyond reactive support, we proactively monitor systems, identify
                         potential issues, and apply preventive measures to avoid future problems.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">7</div>
                    <div class="step-content">
                        <h5>Customized Support Plans</h5>
                        <p>
                        We tailor help desk services to meet your business
                        needs—whether for a small office or a large enterprise—ensuring
                        the right level of support and resources are in place.
                        </p>
                    </div>
                </div>




               <div class="features-included">
                    <h4>Why Choose Our Help Desk Support Services</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p> Quick, professional, and reliable support from certified IT experts.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>24/7 availability to keep your business running without interruptions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Proactive problem prevention and efficient incident resolution.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>  Scalable solutions tailored to your organization’s size and needs.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Features -->
                </div>








                ',
            ],



            [
                'id'=>'7',
                'idlst'=>'4',
                'icon'=>'bi bi-database',
                'title'=>'Database Management',
                'link_ebook'=>'https://book.squareup.com/appointments/7jwdcckk8siagh/location/LGJ2PB5YW3M0K/services/34DSPACOAFHCZLWLWIKISHKF',
                'content'=>'Effective database management is the foundation of reliable business operations and data-driven decision-making. Our <b>Database Management Services</b> ensure your organization’s data is secure, organized, and accessible—optimizing performance, reducing downtime, and enhancing overall productivity. ',
                'description'=>'



                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5>Database Design & Architecture</h5>
                        <p>
                        We design robust and scalable database architectures tailored to your business needs. Our team ensures proper data structuring, normalization, and indexing for optimal performance and future growth.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5>Database Installation & Configuration</h5>
                        <p>We handle the setup, configuration, and optimization of major database systems including <b>MySQL, SQL Server, Oracle, PostgreSQL, and MongoDB</b>. Our experts ensure seamless integration with your existing IT infrastructure.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5>Data Backup & Recovery</h5>
                        <p>
                       Data loss can be catastrophic. We implement automated backup and disaster recovery plans to ensure your data is protected and quickly recoverable in case of hardware failure, cyberattack, or system crash.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5>Performance Monitoring & Optimization</h5>
                        <p>
                        Our monitoring tools continuously track your database performance—analyzing queries, indexing, and workloads—to eliminate bottlenecks and improve speed, stability, and efficiency.
                        </p>
                    </div>
                </div>


                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h5>Database Security & Compliance</h5>
                        <p>
                       We secure your databases against unauthorized access, SQL injection, and data breaches using encryption, access control, and regular vulnerability assessments. Our services also help maintain compliance with regulations such as <b>GDPR, HIPAA, and ISO 27001</b>.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h5>Data Migration & Integration</h5>
                        <p>
                         Whether you’re upgrading to a new system or moving to the cloud, we manage secure and seamless data migration. Our experts ensure zero data loss and minimal downtime during transitions.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">7</div>
                    <div class="step-content">
                        <h5>Cloud Database Solutions</h5>
                        <p>
                          We offer managed cloud database services across <b>AWS, Azure, and Google Cloud</b> platforms—providing scalability, flexibility, and cost-efficiency with round-the-clock monitoring and support.
                        </p>
                    </div>
                </div>


                <div class="step-item">
                    <div class="step-number">8</div>
                    <div class="step-content">
                        <h5>Database Administration (DBA) Support</h5>
                        <p>
                          Our certified DBAs provide 24/7 monitoring, maintenance, and troubleshooting. From routine updates to advanced tuning, we keep your databases running at peak performance with minimal disruption.
                        </p>
                    </div>
                </div>


               <div class="features-included">
                    <h4>Why Choose Our Database Management Services </h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p> Expertise in both on-premises and cloud databases. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>24/7 proactive monitoring and support. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Scalable and customized solutions for businesses of all sizes. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p> Focus on data integrity, performance, and security. </p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Features -->
                </div>






                ',
            ],



            [
                'id'=>'1',
                'idlst'=>'5',
                'icon'=>'bi bi-globe',
                'title'=>'Web Development Services',
                'link_ebook'=>'https://book.squareup.com/appointments/7jwdcckk8siagh/location/LGJ2PB5YW3M0K/services/ZK7RTFHCAMNTTC6UDR5A4N5M',
                'content'=>'In today’s digital-first world, a strong online presence is essential for business growth. Our <b>Web Development Services</b> combine creativity, technology, and strategy to build responsive, user-friendly, and high-performing websites that reflect your brand and drive results. ',
                'description'=>'
                 <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5>Custom Website Development </h5>
                        <p>
                       We create websites tailored to your business needs, whether it’s a corporate site, e-commerce platform, or portfolio. Every website is built with clean code, optimized performance, and a focus on user experience.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5>Front-End Development </h5>
                        <p>
                       Our front-end developers use the latest technologies like <b>HTML5, CSS3, JavaScript, React, and Angular</b> to create interactive and visually appealing websites that engage your audience across all devices.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5>Back-End Development </h5>
                        <p>
                      We ensure robust server-side functionality with <b>Node.js, PHP, Python, Ruby, and Java</b>. Our back-end solutions handle data management, security, and seamless integration with APIs and third-party services.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5>E-commerce Development</h5>
                        <p>
                       From online stores to payment gateways, we build scalable and secure e-commerce solutions using <b>Shopify, WooCommerce, Magento, and custom platforms</b>, enabling smooth shopping experiences and higher conversions.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h5>Content Management Systems (CMS) </h5>
                        <p>
                       We develop CMS-driven websites with platforms like <b>WordPress, Drupal, and Joomla</b>, allowing easy content updates and management without requiring technical expertise.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h5>Website Maintenance & Support </h5>
                        <p>
                        Our team provides ongoing maintenance, updates, and technical support to ensure your website remains secure, fast, and fully functional at all times.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">7</div>
                    <div class="step-content">
                        <h5>SEO & Performance Optimization </h5>
                        <p>
                       We optimize websites for search engines, page speed, and responsiveness to improve visibility, attract more visitors, and enhance user engagement.
                        </p>
                    </div>
                </div>


                <div class="step-item">
                    <div class="step-number">8</div>
                    <div class="step-content">
                        <h5>Mobile-Friendly & Responsive Design </h5>
                        <p>
                       All websites are built to be fully responsive, ensuring they look and function flawlessly on desktops, tablets, and smartphones.
                        </p>
                    </div>
                </div>



               <div class="features-included">
                    <h4>Why Choose Our Web Development Services </h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p> Custom solutions tailored to your business goals.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Focus on performance, security, and scalability.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Expert developers with experience in modern technologies.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>End-to-end support from design to deployment and maintenance.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Features -->
                </div>








                ',
            ],





            [
                'id'=>'2',
                'idlst'=>'3',
                'icon'=>'bi bi-lightbulb',
                'title'=>'IT Support & Consulting Services',
                'link_ebook'=>'https://book.squareup.com/appointments/7jwdcckk8siagh/location/LGJ2PB5YW3M0K/services/CFBKIIL3G2L2VCPXC4WGYJRA',
                'content'=>'In today’s fast-paced digital environment, reliable IT support and expert consulting are critical for business continuity and growth. Our <b>IT Support & Consulting Services</b> provide businesses with the technical expertise, strategic guidance, and proactive solutions needed to optimize IT infrastructure, reduce downtime, and enhance operational efficiency. ',
                'description'=>'

                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5>IT Support & Helpdesk Services  </h5>
                        <p>
                       Our team designs, implements, and manages your IT infrastructure, including servers, networks, and cloud environments, ensuring seamless performance, security, and scalability.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5>IT Infrastructure Management</h5>
                        <p>
                       Our front-end developers use the latest technologies like <b>HTML5, CSS3, JavaScript, React, and Angular</b> to create interactive and visually appealing websites that engage your audience across all devices.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5>IT Consulting & Strategy </h5>
                        <p>
                      We help businesses align technology with strategic goals. Our IT consulting services include technology assessments, roadmap planning, digital transformation guidance, and cost optimization strategies.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5>Network & Security Management </h5>
                        <p>
                       We implement secure networks, monitor for threats, and protect against cyberattacks. Our proactive approach ensures your data, systems, and communications remain safe and compliant.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h5>Cloud Solutions & Migration</h5>
                        <p>
                       We guide businesses in adopting cloud technologies, migrating data securely, and managing cloud infrastructure for improved flexibility, accessibility, and cost-efficiency.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h5>System Monitoring & Maintenance</h5>
                        <p>
                        Our team continuously monitors IT systems, applies updates, and performs preventive maintenance to minimize downtime and ensure optimal performance.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">7</div>
                    <div class="step-content">
                        <h5>Backup & Disaster Recovery</h5>
                        <p>
                       We develop comprehensive backup strategies and disaster recovery plans, safeguarding critical business data and enabling rapid recovery in the event of a system failure or cyber incident.
                        </p>
                    </div>
                </div>



               <div class="features-included">
                    <h4>Why Choose Our IT Support & Consulting Services </h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Certified IT professionals with extensive industry experience. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>24/7 support and proactive monitoring to prevent issues.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Customized IT strategies aligned with your business goals.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Focus on security, efficiency, and scalability for long-term success.</p>
                                </div>
                            </div>
                        </div>


                    </div><!-- End Features -->
                </div>




                ',
            ],



            [
                'id'=>'3',
                'idlst'=>'3',
                'icon'=>'bi bi-shield-lock',
                'title'=>'Cybersecurity Systems & Services ',
                'link_ebook'=>'https://book.squareup.com/appointments/7jwdcckk8siagh/location/LGJ2PB5YW3M0K/services/HTFULCUQE5KYEGAMRJ6IMUNS',
                'content'=>'In today’s digital landscape, cyber threats are more sophisticated than ever. Our <b>Cybersecurity Systems & Services</b> are designed to protect your organization’s data, networks, and digital assets from evolving security risks. We deliver end-to-end protection, proactive threat monitoring, and tailored solutions to keep your systems secure and compliant. ',
                'description'=>'

                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5>Network Security </h5>
                        <p>
                       We implement robust firewalls, intrusion detection systems (IDS), and next-generation threat prevention tools to secure your network infrastructure. Our experts continuously monitor and manage network traffic to identify and stop potential attacks before they cause harm.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5> Endpoint Protection</h5>
                        <p>
                        Your endpoints—laptops, mobile devices, and workstations—are often the first targets for attackers. Our endpoint protection solutions include advanced antivirus, anti-malware, and encryption tools to safeguard every device across your organization.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5>Cloud Security</h5>
                        <p>
                      We secure your cloud environments across AWS, Azure, and Google Cloud using identity management, access control, and encryption strategies. Our cloud security services ensure data privacy, regulatory compliance, and continuous monitoring of your cloud infrastructure.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5>Vulnerability Assessment & Penetration Testing (VAPT)</h5>
                        <p>
                       Through regular vulnerability scans and ethical hacking exercises, we identify security gaps before attackers can exploit them. Our detailed reports include risk ratings, mitigation strategies, and continuous improvement recommendations.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h5>Security Operations Center (SOC)</h5>
                        <p>
                       Our 24/7 SOC team monitors, analyzes, and responds to potential cyber incidents in real time. Using advanced SIEM (Security Information and Event Management) systems, we provide continuous visibility and rapid response to minimize downtime and damage.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h5>Data Protection & Backup Solutions</h5>
                        <p>
                        We help businesses implement secure data storage, encryption, and disaster recovery strategies to ensure critical data remains protected and accessible even in the event of a breach or system failure.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">7</div>
                    <div class="step-content">
                        <h5>Identity & Access Management (IAM)</h5>
                        <p>
                       We establish strong authentication protocols and access controls to ensure only authorized users can access sensitive data. Our IAM solutions reduce insider threats and improve user accountability across your systems.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">8</div>
                    <div class="step-content">
                        <h5>Cyber Awareness Training</h5>
                        <p>
                       Human error is one of the leading causes of breaches. Our customized cybersecurity training programs educate employees on phishing, social engineering, and safe online practices to strengthen your first line of defense.
                        </p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">9</div>
                    <div class="step-content">
                        <h5>Compliance & Governance</h5>
                        <p>
                       We assist organizations in meeting cybersecurity compliance standards such as GDPR, HIPAA, ISO 27001, and NIST. Our team ensures your security posture aligns with both legal and industry best practices.We assist organizations in meeting cybersecurity compliance standards such as GDPR, HIPAA, ISO 27001, and NIST. Our team ensures your security posture aligns with both legal and industry best practices.
                        </p>
                    </div>
                </div>

               <div class="features-included">
                    <h4>Why Choose Us</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Certified cybersecurity professionals (CISSP, CEH, CompTIA Security+).</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>24/7 monitoring and support.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Scalable solutions tailored to your business size and industry.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <p>Proven track record of minimizing risks and protecting business continuity.</p>
                                </div>
                            </div>
                        </div>


                    </div><!-- End Features -->
                </div>




                ',
            ],








        ];





        return $data;
    }

    public function liste_projet_t(){
        $data = [



            [
                'id'=>'3',
                'title'=>'Technology',
            ],


            [
                'id'=>'4',
                'title'=>'Management',
            ],


            [
                'id'=>'5',
                'title'=>'Application',
            ],




            [
                'id'=>'6',
                'title'=>'Help Desk',
            ],



        ];

        return $data;

    }


    public function liste_service(){
        // Utilisation de array_slice() pour récupérer les 6 premiers éléments
        $first_six_items = array_slice($this->liste_service_array(), 0, 6);
        return $first_six_items;
    }

    public function liste_service_all(){
        return $this->liste_service_array();
    }



    public function media_service(){
        return [
            [
                'id'=>'1',
                'id_ref'=>'8',
                'cmd'=>null,
                'active'=>'1',
                'img'=>'helpdesk_support.jpg',
            ],



            [
                'id'=>'2',
                'id_ref'=>'7',
                'cmd'=>null,
                'active'=>'1',
                'img'=>'cloud.jpg',
            ],


            [
                'id'=>'3',
                'id_ref'=>'1',
                'cmd'=>null,
                'active'=>'1',
                'img'=>'dev_web.jpg',
            ],


            [
                'id'=>'4',
                'id_ref'=>'2',
                'cmd'=>null,
                'active'=>'1',
                'img'=>'it_service.jpg',
            ],



            [
                'id'=>'5',
                'id_ref'=>'3',
                'cmd'=>null,
                'active'=>'1',
                'img'=>'technologie.jpg',
            ],



        ];
    }



    public function media_service_header(){
        return [
           [
                'id'=>'1',
                'id_ref'=>'1',
                'active'=>'1',
                'img'=>'services-9.webp',
            ],







        ];
    }





    public function __construct()
    {
        //dd('creation de la table');
        if ($this->tableExists($this->table) == false) {
            $create = $this->tablecreate();
            if ($create == false) {
                echo 'Problem lors de l\' insertion ';
            }
        }

    }


    private function tablecreate(){
        //dd('Table');
        $this->pdoconnect()->exec("CREATE TABLE IF NOT EXISTS ".$this->table." (
            id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
            title varchar(250) NULL,
            subtitle varchar(500) NULL,
            title_sub varchar(500) NULL,
            content text COLLATE latin1_general_ci  NULL,
            content_sub text COLLATE latin1_general_ci  NULL,
            idimg int(100) NULL,
            statuts int(11) NULL,
            lng int(100) NULL,
            iduser int(11) NULL,
            created_at datetime COLLATE latin1_general_ci NULL,
            updated_at datetime COLLATE latin1_general_ci NULL,
            deleted_at datetime COLLATE latin1_general_ci NULL,
            PRIMARY KEY (id) )
            ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;");
        return true;
    }







}
